package utils;

import java.awt.Graphics2D;
import java.awt.RenderingHints;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;

import javax.imageio.ImageIO;

/**
 * 
 * @author Paco
 *
 */
public class PicturesUtils {

	/**
	 * Resize a picture 
	 * @param pathimg
	 * @param width
	 * @param height
	 */
	public void resizePicture(String pathimg, int width, int height){
		File srcimg = new File(pathimg);
		String extension = pathimg.substring(pathimg.lastIndexOf(".")+1);
		BufferedImage newImg = new BufferedImage(width,height,BufferedImage.TYPE_3BYTE_BGR);
		Graphics2D graphImg = newImg.createGraphics();
		graphImg.setRenderingHint(RenderingHints.KEY_INTERPOLATION,RenderingHints.VALUE_INTERPOLATION_BILINEAR);
		try {
			graphImg.drawImage(ImageIO.read(srcimg) ,0, 0, width, height, null);
		} 
		catch (IOException e) {
			e.printStackTrace();
		}
		graphImg.dispose();
		try {
			ImageIO.write(newImg,extension,srcimg);
		} 
		catch (IOException e) {
			e.printStackTrace();
		}
	}

}//end of class
